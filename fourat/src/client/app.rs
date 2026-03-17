use std::{
    io::{self, Result, Write},
    thread,
    time::Duration,
    vec,
};

use crossterm::{
    ExecutableCommand, QueueableCommand,
    cursor::MoveTo,
    event::{
        self, DisableMouseCapture, EnableMouseCapture, Event, KeyCode, KeyEventKind, KeyModifiers,
        MouseEventKind,
    },
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
        self.stdout.execute(EnableMouseCapture)?;

        while self.alive {
            while event::poll(Duration::ZERO)? {
                self.handle_events()?;
            }
            self.render_frame()?;
            thread::sleep(Duration::from_millis(33));
        }

        self.stdout.execute(DisableMouseCapture)?;
        terminal::disable_raw_mode()?;
        self.stdout.execute(LeaveAlternateScreen)?;

        Ok(())
    }

    fn cursor_up(&mut self) {
        let max_cursor = if self.messages.len() > 0 {
            (self.messages.len() - 1) as u16
        } else {
            0
        };
        if self.cursor < max_cursor {
            self.cursor += 1;
        }
    }

    fn cursor_down(&mut self) {
        if self.cursor > 0 {
            self.cursor -= 1;
        }
    }

    fn handle_events(&mut self) -> Result<()> {
        match event::read()? {
            Event::Resize(width, height) => {
                self.width = width;
                self.height = height;
            }
            Event::Mouse(mouse_event) => match mouse_event.kind {
                MouseEventKind::ScrollUp => self.cursor_up(),
                MouseEventKind::ScrollDown => self.cursor_down(),
                _ => (),
            },
            Event::Key(key_event) if key_event.kind == KeyEventKind::Press => {
                match key_event.code {
                    KeyCode::Char('c') if key_event.modifiers.contains(KeyModifiers::CONTROL) => {
                        self.alive = false;
                    }
                    KeyCode::Up if key_event.modifiers.contains(KeyModifiers::SHIFT) => {
                        self.cursor_up();
                    }
                    KeyCode::Down if key_event.modifiers.contains(KeyModifiers::SHIFT) => {
                        self.cursor_down();
                    }
                    KeyCode::Backspace => {
                        self.prompt.pop();
                    }
                    KeyCode::Char(char) if !key_event.modifiers.contains(KeyModifiers::CONTROL) => {
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
        let chat_first_row = 2;
        let chat_last_row = self.height - 3;

        let mut row = chat_last_row;

        let cursor_offset = (self.cursor as usize).min(self.messages.len());

        let mut index = self.messages.len().saturating_sub(cursor_offset);

        self.stdout
            .queue(MoveTo(0, 0))?
            .queue(Print(format!("Cursor: {} Index: {}", self.cursor, index)))?;

        while row > chat_first_row && index > 0 {
            index -= 1;

            if row != chat_last_row {
                row -= 1;
            }

            let message = &self.messages[index];

            let parts = wrap_message(&message.content, self.width as usize);

            for part in parts.iter().rev() {
                if row <= chat_first_row {
                    break;
                }

                self.stdout.queue(MoveTo(0, row))?.queue(Print(part))?;

                row -= 1;
            }

            if row <= chat_first_row {
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
