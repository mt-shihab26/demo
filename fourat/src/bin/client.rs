use std::time::Duration;

use crossterm::event::{poll, read};

fn main() {
    loop {
        while poll(Duration::ZERO).unwrap() {
            match read().unwrap() {
                crossterm::event::Event::FocusGained => todo!(),
                crossterm::event::Event::FocusLost => todo!(),
                crossterm::event::Event::Key(key_event) => todo!(),
                crossterm::event::Event::Mouse(mouse_event) => todo!(),
                crossterm::event::Event::Paste(_) => todo!(),
                crossterm::event::Event::Resize(_, _) => todo!(),
            }
        }
    }
}
