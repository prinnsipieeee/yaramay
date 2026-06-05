if (typeof WOW !== 'undefined') {
  new WOW().init();
}
if (typeof AOS !== 'undefined') {
  AOS.init();
}

(function () {
  var params = new URLSearchParams(window.location.search);
  var status = params.get('contact');
  if (!status) return;

  var alertEl = document.getElementById('contact-alert');
  if (!alertEl) return;

  var reason = params.get('reason');
  var messages = {
    success: 'Thank you! Your message has been sent. We will get back to you soon.',
    error: {
      missing: 'Please fill in all fields before sending.',
      email: 'Please enter a valid email address.',
      send: 'We could not send your message. Please try again later or email us directly.',
    },
  };

  alertEl.classList.remove('d-none', 'alert-success', 'alert-danger');
  if (status === 'success') {
    alertEl.classList.add('alert-success');
    alertEl.textContent = messages.success;
    var form = document.getElementById('contact-form');
    if (form) form.reset();
  } else {
    alertEl.classList.add('alert-danger');
    alertEl.textContent =
      (messages.error && messages.error[reason]) || messages.error.send;
  }

  params.delete('contact');
  params.delete('reason');
  var query = params.toString();
  var cleanUrl =
    window.location.pathname +
    (query ? '?' + query : '') +
    window.location.hash;
  window.history.replaceState({}, '', cleanUrl);
})();
