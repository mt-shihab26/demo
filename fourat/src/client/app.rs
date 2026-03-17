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

pub struct App {}

impl App {
    pub fn new() -> Self {
        Self {}
    }

    pub fn run(&mut self) -> io::Result<()> {
        let mut stdout = io::stdout();
        let (mut width, mut height) = terminal::size()?;

        loop {
            while event::poll(Duration::ZERO)? {
                handle_events(&mut width, &mut height)?;
            }
            render_frame(&mut stdout)?;
            thread::sleep(Duration::from_millis(33));
        }
    }
}

fn handle_events(width: &mut u16, height: &mut u16) -> io::Result<()> {
    match event::read()? {
        Event::Resize(w, h) => {
            *width = w;
            *height = h;
        }
        Event::Key(_) => todo!(),
        _ => (),
    }

    Ok(())
}

fn render_frame(stdout: &mut io::Stdout) -> io::Result<()> {
    stdout.queue(terminal::Clear(terminal::ClearType::All))?;

    for y in 0..40 {
        for x in 0..150 {
            if (y == 0 || y == 40 - 1) || (x == 0 || x == 150 - 1) {
                stdout
                    .queue(cursor::MoveTo(x, y))?
                    .queue(style::PrintStyledContent("█".magenta()))?;
            }
        }
    }

    stdout.flush()?;

    Ok(())
}
