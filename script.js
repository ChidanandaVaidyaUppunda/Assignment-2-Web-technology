$(function () {
  const $form = $('#applicationForm');
  if (!$form.length) return;

  $form.on('submit', function (event) {
    let firstInvalid = null;
    const messages = [];
    $form.find('input:not([type="checkbox"]), select, textarea').each(function () {
      const $field = $(this);
      $field.removeClass('invalid');
      if ($field.prop('required') && !$field.val().trim()) {
        $field.addClass('invalid');
        messages.push('Please complete ' + ($field.prev('label').text().replace('*', '').trim() || 'all required fields') + '.');
        if (!firstInvalid) firstInvalid = this;
      }
    });

    const email = $('#email').val().trim();
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      $('#email').addClass('invalid');
      messages.push('Please enter a valid email address.');
      if (!firstInvalid) firstInvalid = $('#email')[0];
    }
    const phone = $('#phone').val().trim();
    if (phone && !/^[0-9+()\-\s]{7,20}$/.test(phone)) {
      $('#phone').addClass('invalid');
      messages.push('Please enter a valid phone number.');
      if (!firstInvalid) firstInvalid = $('#phone')[0];
    }
    if (!$('#confirm').is(':checked')) {
      $('.consent').addClass('error');
      messages.push('Please confirm that your information is accurate.');
      if (!firstInvalid) firstInvalid = $('#confirm')[0];
    } else {
      $('.consent').removeClass('error');
    }

    if (messages.length) {
      event.preventDefault();
      $('#clientMessage').html(messages.map(function (message) {
        return $('<div>').text(message).prop('outerHTML');
      }).join(''));
      if (firstInvalid) firstInvalid.focus();
    } else {
      $('#clientMessage').text('Submitting your application…');
    }
  });

  $form.on('input change', 'input, select, textarea', function () {
    $(this).removeClass('invalid');
    $('#clientMessage').empty();
  });
});
