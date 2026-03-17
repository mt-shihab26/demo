use std::{thread, time::Duration};

use crossterm::{event, terminal};

fn main() {
    let (mut width, mut height) = terminal::size().unwrap();

    loop {
        while event::poll(Duration::ZERO).unwrap() {
            handle_events(&mut width, &mut height);
        }
        render_frame();

        thread::sleep(Duration::from_millis(33));
    }
}

fn handle_events(width: &mut u16, height: &mut u16) {
    match event::read().unwrap() {
        event::Event::Resize(w, h) => {
            *width = w;
            *height = h;
        }
        event::Event::Key(_) => todo!(),
        _ => (),
    }
}

fn render_frame() {
    //
}
