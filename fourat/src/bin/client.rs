use std::time::Duration;

use crossterm::{
    event::{Event, poll, read},
    terminal,
};

fn main() {
    let (mut width, mut height) = terminal::size().unwrap();

    loop {
        while poll(Duration::ZERO).unwrap() {
            handle_events(&mut width, &mut height);
        }

        render_frame();
    }
}

fn handle_events(width: &mut u16, height: &mut u16) {
    match read().unwrap() {
        Event::Resize(w, h) => {
            *width = w;
            *height = h;
        }
        Event::Key(_) => todo!(),
        _ => (),
    }
}

fn render_frame() {
    //
}
