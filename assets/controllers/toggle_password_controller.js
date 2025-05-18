import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['password']

  toggle(event) {
    event.preventDefault();

    if (this.passwordTarget.type === 'password') {
      this.passwordTarget.type = 'text';
    } else {
      this.passwordTarget.type = 'password';
    }
  }
}
