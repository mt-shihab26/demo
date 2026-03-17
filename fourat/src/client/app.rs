use std::{
    io::{self, Write},
    thread,
    time::Duration,
};

use crossterm::{
    QueueableCommand, cursor,
    event::{self, Event},
    style::{self, Stylize},
    terminal,
};

pub struct App {
    stdout: io::Stdout,
    width: u16,
    height: u16,
}

impl App {
    pub fn new() -> io::Result<Self> {
        let stdout = io::stdout();
        let (width, height) = terminal::size()?;

        Ok(Self {
            stdout,
            width,
            height,
        })
    }

    pub fn run(&mut self) -> io::Result<()> {
        loop {
            while event::poll(Duration::ZERO)? {
                self.handle_events()?;
            }
            self.render_frame()?;
            thread::sleep(Duration::from_millis(33));
        }
    }

    fn handle_events(&mut self) -> io::Result<()> {
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

    fn render_frame(&mut self) -> io::Result<()> {
        self.stdout
            .queue(terminal::Clear(terminal::ClearType::All))?;

        for y in 0..40 {
            for x in 0..150 {
                if (y == 0 || y == 40 - 1) || (x == 0 || x == 150 - 1) {
                    self.stdout
                        .queue(cursor::MoveTo(x, y))?
                        .queue(style::PrintStyledContent("█".magenta()))?;
                }
            }
        }

        self.stdout.flush()?;

        Ok(())
    }
}
