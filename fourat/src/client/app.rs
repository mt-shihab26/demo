use std::{
    io::{self, Result, Write},
    thread,
    time::Duration,
};

use crossterm::{
    QueueableCommand,
    cursor::MoveTo,
    event::{self, Event},
    style::{PrintStyledContent, Stylize},
    terminal::{self, Clear, ClearType},
};

pub struct App {
    stdout: io::Stdout,
    width: u16,
    height: u16,
}

impl App {
    pub fn new() -> Result<Self> {
        let stdout = io::stdout();
        let (width, height) = terminal::size()?;

        Ok(Self {
            stdout,
            width,
            height,
        })
    }

    pub fn run(&mut self) -> Result<()> {
        loop {
            while event::poll(Duration::ZERO)? {
                self.handle_events()?;
            }
            self.render_frame()?;
            thread::sleep(Duration::from_millis(33));
        }
    }

    fn handle_events(&mut self) -> Result<()> {
        match event::read()? {
            Event::Resize(width, height) => {
                self.width = width;
                self.height = height;
            }
            Event::Key(_) => todo!(),
            _ => (),
        }

        Ok(())
    }

    fn render_frame(&mut self) -> Result<()> {
        self.stdout.queue(Clear(ClearType::All))?;

        for y in 0..self.height {
            for x in 0..self.width {
                if (y == 0 || y == self.height - 1) || (x == 0 || x == self.width - 1) {
                    self.stdout
                        .queue(MoveTo(x, y))?
                        .queue(PrintStyledContent("█".magenta()))?;
                }
            }
        }

        self.stdout.flush()?;

        Ok(())
    }
}
