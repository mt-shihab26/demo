import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    reply(event) {
        const targetId = event.currentTarget.dataset.target;
        const element = document.getElementById(targetId);
        if (element) {
            element.classList.remove("hidden");
        }
    }

    cancel(event) {
        const targetId = event.currentTarget.dataset.target;
        const element = document.getElementById(targetId);
        if (element) {
            element.classList.add("hidden");
            // Clear the textarea
            const textarea = element.querySelector("textarea");
            if (textarea) {
                textarea.value = "";
            }
        }
    }
}
