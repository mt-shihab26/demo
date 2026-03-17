pub struct Message {
    pub user: String,
    pub content: String,
}

impl Message {
    pub fn new(user: &str, content: &str) -> Self {
        Self {
            user: user.to_string(),
            content: content.to_string(),
        }
    }
}

pub fn fake_messages() -> Vec<Message> {
    vec![
        Message::new("Alice", "Hey everyone! How's it going?"),
        Message::new("Bob", "Pretty good! Just finished that new feature."),
        Message::new("Charlie", "Nice work Bob! Can you share the details?"),
        Message::new("Alice", "I'm curious too!"),
        Message::new(
            "Bob",
            "Sure! It's a message system with fake data generation.",
        ),
        Message::new("Diana", "That sounds interesting!"),
        Message::new("Charlie", "When can we test it out?"),
        Message::new("Bob", "It's ready now, actually."),
        Message::new("Alice", "Awesome! Let's give it a try."),
        Message::new("Diana", "Great work team!"),
    ]
}
