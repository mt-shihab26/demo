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
        Message::new(
            "Eve",
            "Just joined the conversation! What did I miss? Looks like there's been a lot of exciting development happening here today!",
        ),
        Message::new(
            "Bob",
            "Welcome Eve! We've been discussing the new message system I just finished. It's going to revolutionize how we handle testing scenarios.",
        ),
        Message::new(
            "Frank",
            "That's amazing news! I've been looking forward to this feature for quite some time now. Will it support different message formats?",
        ),
        Message::new(
            "Alice",
            "Great question Frank! Bob, can you tell us more about the format support and customization options that are available in the system?",
        ),
        Message::new(
            "Bob",
            "Absolutely! The system supports multiple formats including plain text, JSON, and even custom formats that you can define yourself.",
        ),
        Message::new(
            "Charlie",
            "This is getting better and better! How about internationalization? Can we generate messages in different languages for testing purposes?",
        ),
        Message::new(
            "Diana",
            "That would be incredibly useful for our global users. We really need to ensure our application works well across different locales.",
        ),
        Message::new(
            "Eve",
            "I agree with Diana. Internationalization is crucial these days, especially when we're targeting markets in Asia, Europe, and South America.",
        ),
        Message::new(
            "Bob",
            "Good news! I've already included basic i18n support. Right now it supports English, Spanish, French, German, and Japanese message generation.",
        ),
        Message::new(
            "Frank",
            "Wow, you really thought of everything! How long did it take you to implement all of these features? It must have been quite a journey.",
        ),
        Message::new(
            "Alice",
            "I'm impressed with the scope of this implementation. Did you have to refactor a lot of existing code to make this work seamlessly?",
        ),
        Message::new(
            "Bob",
            "It took about three weeks of focused development. The refactoring was significant but necessary to ensure clean integration with our existing systems.",
        ),
        Message::new(
            "Charlie",
            "Three weeks is quite reasonable for such a comprehensive feature. Did you encounter any particularly challenging bugs during the development process?",
        ),
        Message::new(
            "Diana",
            "I'm curious about the testing strategy you used. How did you ensure that everything works correctly before pushing it to the main branch?",
        ),
        Message::new(
            "Eve",
            "Yes, testing is always the critical part! I hope there's comprehensive test coverage for all the new functionality you've implemented.",
        ),
        Message::new(
            "Bob",
            "I wrote over 200 unit tests and 50 integration tests to cover all the major use cases. The test coverage is sitting at around 95 percent right now.",
        ),
        Message::new(
            "Frank",
            "That's excellent test coverage! It's always reassuring to know that new features are properly tested before they hit production environments.",
        ),
        Message::new(
            "Alice",
            "I really appreciate the attention to quality. It shows a lot of professionalism and care for the codebase. Great job on maintaining high standards!",
        ),
        Message::new(
            "Charlie",
            "Definitely! Quality over speed is always the right approach. Does the system support batch message generation for performance testing scenarios?",
        ),
        Message::new(
            "Bob",
            "Yes indeed! You can generate anywhere from a single message to millions of messages for stress testing and performance benchmarking purposes.",
        ),
        Message::new(
            "Diana",
            "That's perfect for our upcoming load testing phase. We need to ensure our infrastructure can handle peak traffic during major events.",
        ),
        Message::new(
            "Eve",
            "Speaking of performance, what kind of throughput can we expect? Are there any benchmarks or metrics you've collected during development?",
        ),
        Message::new(
            "Frank",
            "Good question Eve! Performance metrics are essential when we're planning capacity and infrastructure requirements for production deployment.",
        ),
        Message::new(
            "Bob",
            "I ran some benchmarks yesterday. The system can generate approximately 100,000 messages per second on a standard developer laptop with minimal resource usage.",
        ),
        Message::new(
            "Alice",
            "Those are impressive numbers! That should be more than enough for our current needs and leave plenty of headroom for future growth.",
        ),
        Message::new(
            "Charlie",
            "Absolutely! With those performance characteristics, we won't have to worry about the message generation becoming a bottleneck in our testing pipeline.",
        ),
        Message::new(
            "Diana",
            "This is shaping up to be one of the most useful tools in our testing arsenal. I can't wait to start using it in our daily workflows!",
        ),
        Message::new(
            "Eve",
            "Same here! When can we expect to see the documentation? I'd like to read through it and understand all the available configuration options.",
        ),
        Message::new(
            "Bob",
            "The documentation is already available in the docs folder! I've included examples, API references, and a comprehensive getting started guide.",
        ),
        Message::new(
            "Frank",
            "Perfect! I'll dive into the documentation this afternoon and start experimenting with different configurations to see what works best for our use cases.",
        ),
        Message::new(
            "Alice",
            "I'll do the same! Maybe we can schedule a team meeting next week to share our experiences and discuss best practices for using this new tool?",
        ),
        Message::new(
            "Charlie",
            "That's a great idea Alice! Having everyone share their insights will help us all learn faster and avoid common pitfalls in the beginning.",
        ),
        Message::new(
            "Diana",
            "I'll send out a meeting invite for next Tuesday afternoon. Does that work for everyone? Please let me know if you have any conflicts.",
        ),
        Message::new(
            "Eve",
            "Tuesday afternoon works perfectly for me! I'm really looking forward to this meeting and hearing about everyone's experiences with the new system.",
        ),
        Message::new(
            "Bob",
            "Sounds good to me! I'll prepare a brief presentation covering the key features and some advanced usage patterns that might not be obvious from the docs.",
        ),
        Message::new(
            "Frank",
            "Excellent! In the meantime, I'll start integrating it into our continuous integration pipeline to automate some of our testing scenarios.",
        ),
        Message::new(
            "Alice",
            "That's a smart move Frank! Automation is key to getting the most value out of tools like this. Let us know if you run into any issues!",
        ),
        Message::new(
            "Charlie",
            "I'm planning to use it for our API testing framework. It should make it much easier to generate realistic test data for various endpoint scenarios.",
        ),
        Message::new(
            "Diana",
            "Great idea Charlie! We definitely need better test data for our API tests. The current mock data is too simplistic and doesn't catch edge cases.",
        ),
        Message::new(
            "Eve",
            "I'm thinking about using it for UI testing as well. Having realistic message data will make our frontend tests much more robust and reliable.",
        ),
        Message::new(
            "Bob",
            "I love hearing all these different use cases! It's exactly what I hoped for when I started designing this system. The flexibility was a key goal.",
        ),
        Message::new(
            "Frank",
            "You definitely achieved that goal! The design seems very flexible and extensible. Are there plans for plugins or extensions in the future?",
        ),
        Message::new(
            "Alice",
            "That's an interesting thought! A plugin system could allow the community to contribute additional message generators for specialized use cases.",
        ),
        Message::new(
            "Charlie",
            "We could have plugins for different domains like e-commerce, social media, financial transactions, and more. The possibilities are endless!",
        ),
        Message::new(
            "Diana",
            "I think we should focus on stabilizing the core functionality first before adding too many features. Let's make sure what we have now works perfectly.",
        ),
        Message::new(
            "Eve",
            "Diana makes a good point. It's important to have a solid foundation before building additional layers of complexity on top of it.",
        ),
        Message::new(
            "Bob",
            "I agree with both perspectives. Let's use it for a few months, gather feedback, and then decide on the roadmap for future enhancements.",
        ),
        Message::new(
            "Frank",
            "That's a sensible approach! Real-world usage will reveal what features are truly needed versus what just sounds good on paper initially.",
        ),
        Message::new(
            "Alice",
            "Exactly! User feedback is invaluable for prioritizing development efforts and ensuring we're building things that people actually need and want.",
        ),
        Message::new(
            "Charlie",
            "Has anyone thought about security implications? We should make sure the generated messages don't accidentally contain sensitive information patterns.",
        ),
        Message::new(
            "Diana",
            "That's a crucial point Charlie! We need to audit the message generation logic to ensure it doesn't produce anything that could be problematic.",
        ),
        Message::new(
            "Eve",
            "Good catch! Security should always be a top priority, especially when we're dealing with systems that generate or process message data.",
        ),
        Message::new(
            "Bob",
            "I've implemented filters to prevent generation of common sensitive patterns like credit card numbers, social security numbers, and email addresses.",
        ),
        Message::new(
            "Frank",
            "That's reassuring! Are there configuration options to customize what patterns should be filtered based on specific compliance requirements?",
        ),
        Message::new(
            "Alice",
            "Yes, configurability is important here because different organizations have different definitions of what constitutes sensitive information exposure.",
        ),
        Message::new(
            "Bob",
            "The filter configuration is fully customizable through a YAML file. You can add your own patterns or disable certain filters if needed.",
        ),
        Message::new(
            "Charlie",
            "Perfect! That gives us the flexibility we need while still providing sensible defaults that work for most common scenarios out of the box.",
        ),
        Message::new(
            "Diana",
            "I appreciate the attention to security and configurability. It shows mature engineering thinking and consideration for real-world deployment scenarios.",
        ),
        Message::new(
            "Eve",
            "Agreed! These are the kinds of details that separate a toy project from a production-ready tool that teams can actually rely on daily.",
        ),
        Message::new(
            "Frank",
            "Speaking of production readiness, what about logging and monitoring? Can we track message generation metrics for operational visibility?",
        ),
        Message::new(
            "Alice",
            "Good question! Observability is essential for production systems. We need to know what's happening and be able to debug issues when they arise.",
        ),
        Message::new(
            "Bob",
            "I've integrated with our standard logging framework and exposed Prometheus metrics for message generation rates, errors, and latency distributions.",
        ),
        Message::new(
            "Charlie",
            "Excellent! That means we can set up alerts for any anomalies and track the system's health over time using our existing monitoring infrastructure.",
        ),
        Message::new(
            "Diana",
            "This is really comprehensive work Bob! You've thought through all the operational concerns that often get overlooked in initial implementations.",
        ),
        Message::new(
            "Eve",
            "I'm genuinely impressed! It's rare to see a first version of a tool that's this well thought out and production ready from day one.",
        ),
        Message::new(
            "Frank",
            "Bob, you've set a high bar for feature development! This should serve as a template for how we approach building new tools and systems.",
        ),
        Message::new(
            "Alice",
            "Absolutely! The combination of functionality, performance, security, and observability makes this a model implementation for the entire engineering team.",
        ),
        Message::new(
            "Charlie",
            "I'm excited to start using this in my projects! Let me know if anyone wants to pair program on integration. I'm happy to help!",
        ),
        Message::new(
            "Diana",
            "That's generous of you Charlie! I might take you up on that offer when I start integrating it into our mobile testing framework next week.",
        ),
        Message::new(
            "Eve",
            "I'd be interested in pairing as well! Two heads are often better than one, especially when learning a new tool or system for the first time.",
        ),
        Message::new(
            "Bob",
            "I love the collaborative spirit here! Feel free to ping me anytime if you run into issues or have questions about the implementation details.",
        ),
        Message::new(
            "Frank",
            "This has been such a productive conversation! I'm energized and ready to dive in. Thanks everyone for the great discussion and insights!",
        ),
        Message::new(
            "Alice",
            "Same here! It's conversations like these that make me appreciate our team culture. Everyone brings such valuable perspectives to the table.",
        ),
        Message::new(
            "Charlie",
            "Agreed! Now let's go put this amazing new tool to work and see what incredible things we can build with it. Exciting times ahead!",
        ),
        Message::new(
            "Diana",
            "Before we wrap up, does anyone have any final questions or concerns that we should address while we're all here together on this thread?",
        ),
        Message::new(
            "Eve",
            "I don't have any questions right now, but I'll definitely reach out if something comes up as I start working with the system this week.",
        ),
        Message::new(
            "Bob",
            "No worries! I'll be around and monitoring the team chat. Don't hesitate to ask anything, no matter how small or obvious it might seem!",
        ),
        Message::new(
            "Frank",
            "Thanks Bob! Your willingness to help and support the team really makes a difference. It's what makes our engineering culture so strong.",
        ),
        Message::new(
            "Alice",
            "Alright everyone, I need to jump into another meeting now. Thanks for the great discussion and I'll see you all at Tuesday's meeting!",
        ),
        Message::new(
            "Charlie",
            "Have a good meeting Alice! I should get back to work too. Got some code reviews waiting for me. Catch you all later today!",
        ),
        Message::new(
            "Diana",
            "Thanks everyone! This was really productive. I'll send out that meeting invite shortly. Have a great rest of your day everyone!",
        ),
        Message::new(
            "Eve",
            "See you all later! Time to grab some lunch and then dive into the documentation. Really looking forward to working with this new tool!",
        ),
        Message::new(
            "Bob",
            "Enjoy your lunch Eve! Thanks everyone for the positive feedback and great questions. It really motivates me to keep building useful tools for the team!",
        ),
        Message::new(
            "Frank",
            "Alright team, signing off for now! Let's reconvene on Tuesday with our experiences and learnings. Until then, happy coding everyone!",
        ),
        Message::new(
            "Alice",
            "One more quick thing - should we create a dedicated Slack channel for questions and discussions about this new message generation system?",
        ),
        Message::new(
            "Charlie",
            "That's a smart idea! It would help centralize knowledge and make it easier for everyone to learn from each other's questions and solutions.",
        ),
        Message::new(
            "Diana",
            "I'll create the channel right now! Let's call it message-gen-support. I'll add everyone to it and pin the documentation link at the top.",
        ),
        Message::new(
            "Eve",
            "Perfect! That will make it much easier to collaborate and share tips and tricks as we all start using the system in our different projects.",
        ),
        Message::new(
            "Bob",
            "Thanks Diana! I'll make sure to monitor that channel closely, especially in these first few weeks as everyone is getting up to speed with everything.",
        ),
        Message::new(
            "Frank",
            "Great initiative! Having a dedicated space will also help preserve institutional knowledge for future team members who join us down the line.",
        ),
        Message::new(
            "Alice",
            "Exactly! Documentation is important, but sometimes the real gold is in the community discussions and problem-solving that happens organically in channels.",
        ),
        Message::new(
            "Charlie",
            "Alright, now I really need to get back to work! Looking forward to all the great discussions in the new channel. See you all there!",
        ),
        Message::new(
            "Diana",
            "Channel is created and everyone is added! Feel free to start posting questions, tips, or anything else related to the message generation system.",
        ),
        Message::new(
            "Eve",
            "Thanks Diana! I just joined the channel. This is going to be a great resource for the team. Really excited about this whole initiative!",
        ),
        Message::new(
            "Bob",
            "Me too! It's wonderful to see how enthusiastic everyone is. This is exactly the kind of team energy that leads to great products and innovations.",
        ),
        Message::new(
            "Frank",
            "Couldn't agree more! Now let's all get back to our respective tasks and reconvene with our experiences next week. Happy building everyone!",
        ),
        Message::new(
            "Alice",
            "Sounds like a plan! Thanks again Bob for all your hard work on this. And thanks everyone for such an engaging and productive discussion today!",
        ),
        Message::new(
            "Charlie",
            "Cheers everyone! Time to turn all this excitement into actual working code. See you in the new Slack channel and at next week's meeting!",
        ),
        Message::new(
            "Diana",
            "Perfect way to wrap this up! Let's make the most of this new tool and continue to support each other. Talk to you all soon!",
        ),
        Message::new(
            "Eve",
            "Goodbye everyone! This has been wonderful. Looking forward to our continued collaboration. Until next time, happy coding and stay awesome!",
        ),
        Message::new(
            "Bob",
            "Thanks all! This conversation has made my day. Knowing that my work is helpful to the team makes all those late nights worth it. See you soon!",
        ),
        Message::new(
            "Frank",
            "And with that, I think we can officially call this conversation a wrap! Thanks everyone for your time, insights, and positive energy today!",
        ),
        Message::new(
            "Alice",
            "One last thing before I go - let's not forget to celebrate these wins! We should acknowledge great work when we see it. Kudos to Bob again!",
        ),
        Message::new(
            "Charlie",
            "Absolutely! Maybe we should add this to our next team retrospective as an example of successful feature development and team collaboration.",
        ),
        Message::new(
            "Diana",
            "Great idea Charlie! I'll make a note to include it in the retro agenda. It's important to learn from our successes, not just our failures.",
        ),
        Message::new(
            "Eve",
            "Love that perspective! Positive reinforcement and learning from what works well is just as valuable as post-mortem analysis of what went wrong.",
        ),
        Message::new(
            "Bob",
            "You guys are making me blush! But seriously, this has been incredibly encouraging. Thank you all for being such supportive teammates!",
        ),
        Message::new(
            "Frank",
            "Alright, now we really should get back to work before we spend the entire day in this chat thread! Final goodbye everyone, catch you later!",
        ),
    ]
}
