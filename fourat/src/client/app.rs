use std::{
    io::{self, Result, Write},
    thread,
    time::Duration,
};

use crossterm::{
    ExecutableCommand, QueueableCommand,
    cursor::MoveTo,
    event::{self, Event, KeyCode, KeyEventKind, KeyModifiers},
    style::{Print, PrintStyledContent, Stylize},
    terminal::{self, Clear, ClearType, EnterAlternateScreen, LeaveAlternateScreen},
};

pub struct App {
    alive: bool,
    stdout: io::Stdout,
    width: u16,
    height: u16,
    prompt: String,
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
                    KeyCode::Backspace => {
                        self.prompt.pop();
                    }
                    KeyCode::Char(char) => {
                        self.prompt.push(char);
                    }
                    _ => (),
                }
            }
            _ => (),
        }

        Ok(())
    }

    fn render_frame(&mut self) -> Result<()> {
        let stdout = &mut self.stdout;

        stdout.queue(Clear(ClearType::All))?;

        for y in 0..self.height {
            for x in 0..self.width {
                if y == self.height - 2 {
                    stdout
                        .queue(MoveTo(x, y))?
                        .queue(PrintStyledContent("─".magenta()))?;
                }
            }
        }

        stdout
            .queue(MoveTo(0, self.height - 1))?
            .queue(Print(&self.prompt))?;

        stdout.flush()?;

        Ok(())
    }
}
