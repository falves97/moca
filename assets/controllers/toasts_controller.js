import {Controller} from '@hotwired/stimulus';
import {bootstrap} from '@tabler/core';

export default class extends Controller {
  connect() {
    const toast = new bootstrap.Toast(this.element);
    toast.show();
  }
}
