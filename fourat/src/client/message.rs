use fake::{
    Dummy, Fake, Faker,
    faker::{lorem::en::Sentence, name::en::Name},
};

#[derive(Debug, Dummy)]
pub struct Message {
    #[dummy(faker = "Name()")]
    pub user: String,
    #[dummy(faker = "Sentence(10..50)")]
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
    (0..110).map(|_| Faker.fake::<Message>()).collect()
}
