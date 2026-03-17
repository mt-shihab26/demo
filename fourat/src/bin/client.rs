use std::{
    io::{self, Write},
    thread,
    time::Duration,
};

use crossterm::{
    QueueableCommand,
    event::{self, Event},
    style, terminal,
};

fn main() {
    let mut stdout = io::stdout();
    let (mut width, mut height) = terminal::size().unwrap();

    loop {
        while event::poll(Duration::ZERO).unwrap() {
            handle_events(&mut width, &mut height);
        }
        render_frame(&mut stdout);

        thread::sleep(Duration::from_millis(33));
    }
}

fn handle_events(width: &mut u16, height: &mut u16) {
    match event::read().unwrap() {
        Event::Resize(w, h) => {
            *width = w;
            *height = h;
        }
        Event::Key(_) => todo!(),
        _ => (),
    }
}

fn render_frame(stdout: &mut io::Stdout) {
    stdout.queue(style::Print("Hello")).unwrap();
    stdout.flush().unwrap();
}
