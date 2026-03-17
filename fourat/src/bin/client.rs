use std::io;

use fourat::client::app::App;

fn main() -> io::Result<()> {
    let mut app = App::new();

    app.run()
}
