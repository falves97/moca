import {Controller} from "@hotwired/stimulus";
import {bootstrap} from "@tabler/core";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ['userAvatar', 'avatarInitials', 'inputAvatar', 'deleteAvatarOption', 'avatarFieldset'];
  static values = {userAvatarUrl: String, userInitials: String};

  initialize() {
    this.dropzoneChange = this.dropzoneChange.bind(this);
    this.dropzoneClear = this.dropzoneClear.bind(this);
  }

  connect() {
    this.element.addEventListener('dropzone:change', this.dropzoneChange);
    this.element.addEventListener('dropzone:clear', this.dropzoneClear);
  }

  disconnect() {
    // You should always remove listeners when the controller is disconnected to avoid side-effects
    this.element.removeEventListener('dropzone:change', this.dropzoneChange);
    this.element.removeEventListener('dropzone:clear', this.dropzoneClear);
  }

  deleteAvatarOptionTargetConnected(element) {
    element.value = null;
  }

  inputAvatarTargetConnected(element) {
    if (element.checked) {
      this.userAvatarUrlValue = element.dataset.userSettingsImageUrlParam;
      this.updateAvatarImage();
    }
  }

  avatarFieldsetTargetConnected(element) {
    if (!element.classList.contains('show')) {
      new bootstrap.Collapse(element).show();
    }
  }

  setAvatarImageUrl(event) {
    this.deleteAvatarOptionTarget.value = null;
    this.userAvatarUrlValue = event.params.imageUrl;
  }

  updateAvatarImage() {
    if (this.userAvatarUrlValue) {
      this.deleteAvatarOptionTarget.value = null;
      this.avatarInitialsTarget.innerHTML = '';
      this.userAvatarTarget.style.backgroundImage = `url(${this.userAvatarUrlValue})`;
    }
  }

  deleteAvatar() {
    this.userAvatarUrlValue = '';
    this.deleteAvatarOptionTarget.value = true;
    this.inputAvatarTargets.forEach(input => input.checked = false);
    this.avatarInitialsTarget.innerHTML = this.userInitialsValue;
    this.userAvatarTarget.style.backgroundImage = '';
    this.userAvatarTarget.style.backgroundImageUrl = '';
  }

  dropzoneChange(event) {
    this.avatarFieldsetTarget.disabled = true;
    this.deleteAvatarOptionTarget.value = null;
    this.userAvatarUrlValue = window.URL.createObjectURL(event.detail);
    new bootstrap.Collapse(this.avatarFieldsetTarget).hide();
  }

  dropzoneClear(event) {
    this.avatarFieldsetTarget.disabled = false;
    this.userAvatarUrlValue = '';
    if (!this.avatarFieldsetTarget.classList.contains('show')) {
      new bootstrap.Collapse(this.avatarFieldsetTarget).show();
    }
  }
}
