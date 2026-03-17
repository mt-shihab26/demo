use std::{
    io::{self, Result, Write},
    thread,
    time::Duration,
    vec,
};

use crossterm::{
    ExecutableCommand, QueueableCommand,
    cursor::MoveTo,
    event::{self, Event, KeyCode, KeyEventKind, KeyModifiers},
    style::Print,
    terminal::{self, Clear, ClearType, EnterAlternateScreen, LeaveAlternateScreen},
};

use crate::client::message::{self, Message};

pub struct App {
    alive: bool,
    stdout: io::Stdout,
    width: u16,
    height: u16,
    prompt: String,
    messages: Vec<Message>,
    cursor: u16,
}

impl App {
    pub fn new() -> Result<Self> {
        let (width, height) = terminal::size()?;

        Ok(Self {
            alive: true,
            stdout: io::stdout(),
            width,
            height,
            prompt: "".to_string(),
            messages: message::fake_messages(),
            cursor: 0,
        })
    }

    pub fn run(&mut self) -> Result<()> {
        terminal::enable_raw_mode()?;
        self.stdout.execute(EnterAlternateScreen)?;

        while self.alive {
            while event::poll(Duration::ZERO)? {
                self.handle_events()?;
            }
            self.render_frame()?;
            thread::sleep(Duration::from_millis(33));
        }

        terminal::disable_raw_mode()?;
        self.stdout.execute(LeaveAlternateScreen)?;

        Ok(())
    }

    fn handle_events(&mut self) -> Result<()> {
        match event::read()? {
            Event::Resize(width, height) => {
                self.width = width;
                self.height = height;
            }
            Event::Key(key_event) if key_event.kind == KeyEventKind::Press => {
                match key_event.code {
                    KeyCode::Char('c') if key_event.modifiers.contains(KeyModifiers::CONTROL) => {
                        self.alive = false;
                    }
                    KeyCode::Char('k') if key_event.modifiers.contains(KeyModifiers::CONTROL) => {
                        self.cursor += 1;
                    }
                    KeyCode::Char('j') if key_event.modifiers.contains(KeyModifiers::CONTROL) => {
                        self.cursor -= 1;
                    }
                    KeyCode::Backspace => {
                        self.prompt.pop();
                    }
                    KeyCode::Char(char) => {
                        self.prompt.push(char);
                    }
                    KeyCode::Enter => {
                        if self.prompt.len() > 0 {
                            self.messages.push(Message::new("Me", &self.prompt));
                            self.prompt.clear();
                        }
                    }
                    _ => (),
                }
            }
            _ => (),
        }

        Ok(())
    }

    fn render_frame(&mut self) -> Result<()> {
        self.stdout.queue(Clear(ClearType::All))?;

        self.render_messages()?;

        self.stdout
            .queue(MoveTo(0, self.height - 2))?
            .queue(Print("─".repeat(self.width as usize)))?;

        self.stdout
            .queue(MoveTo(0, self.height - 1))?
            .queue(Print(&self.prompt))?;

        self.stdout.flush()?;

        Ok(())
    }

    fn render_messages(&mut self) -> Result<()> {
        let chat_height = self.height - 3;

        let mut row = chat_height;
        let mut index = self.messages.len() - (self.cursor as usize);

        self.stdout.queue(Print(&self.cursor.to_string()))?;

        while row > 0 && index > 0 {
            index -= 1;

            if row != chat_height {
                row -= 1;
            }

            let message = &self.messages[index];

            let parts = wrap_message(&message.content, self.width as usize);

            for part in parts.iter().rev() {
                if row == 0 {
                    break;
                }

                self.stdout.queue(MoveTo(0, row))?.queue(Print(part))?;

                row -= 1;
            }

            if row == 0 {
                break;
            }

            self.stdout
                .queue(MoveTo(0, row))?
                .queue(Print(format!("{}:", message.user)))?;

            row -= 1;
        }

        Ok(())
    }
}

fn wrap_message(message: &String, width: usize) -> Vec<String> {
    let mut parts: Vec<String> = vec![];

    let mut remaining = message.as_str();

    while remaining.len() > width {
        let (chunk, left) = remaining.split_at(width);
        parts.push(chunk.to_string());
        remaining = left
    }

    if !remaining.is_empty() {
        parts.push(remaining.to_string());
    }

    parts
}
