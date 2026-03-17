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
        Message::new(
            "Alice",
            "Hey everyone! How's it going today? I hope you're all having a wonderful and productive day so far!",
        ),
        Message::new(
            "Bob",
            "Pretty good! Just finished implementing that new feature we've been discussing for the past few weeks. It took quite a bit of effort but I'm really happy with how it turned out!",
        ),
        Message::new(
            "Charlie",
            "Nice work Bob! That's fantastic news. Can you share the details about the implementation and the approach you took to solve the challenges?",
        ),
        Message::new(
            "Alice",
            "I'm curious too! I'd love to hear more about the technical decisions you made and what trade-offs you considered during development.",
        ),
        Message::new(
            "Bob",
            "Sure! It's a comprehensive message system with fake data generation capabilities, designed to make testing much easier for everyone on the team.",
        ),
        Message::new(
            "Diana",
            "That sounds really interesting and super useful! I can already think of several scenarios where this would save us tons of time during testing.",
        ),
        Message::new(
            "Charlie",
            "When can we start testing it out? I'm excited to integrate this into our workflow and see how it improves our development process.",
        ),
        Message::new(
            "Bob",
            "It's ready now, actually! I just pushed everything to the main branch and updated the documentation with examples and usage instructions.",
        ),
        Message::new(
            "Alice",
            "Awesome! Let's give it a try right away. I'll pull the latest changes and start experimenting with it in my local environment.",
        ),
        Message::new(
            "Diana",
            "Great work team! This collaboration has been amazing and I'm proud of what we've accomplished together on this project!",
        ),
    ]
}
