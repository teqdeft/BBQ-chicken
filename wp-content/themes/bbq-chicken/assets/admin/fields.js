/* bb.q theme – editable fields in the admin: image picker, "Use default", repeatable rows. */
(function ($) {
  'use strict';

  function markChanged(el) { $(el).closest('.bbq-field').addClass('is-changed'); }

  /* Image: pick from the media library */
  $(document).on('click', '[data-bbq-pick]', function () {
    var box = $(this).closest('[data-bbq-image]');
    var frame = wp.media({ title: 'Choose image', library: { type: 'image' }, multiple: false, button: { text: 'Use this image' } });
    frame.on('select', function () {
      var a = frame.state().get('selection').first().toJSON();
      box.find('input[type=hidden]').val(a.id);
      box.find('img').attr('src', a.sizes && a.sizes.medium ? a.sizes.medium.url : a.url);
      markChanged(box);
    });
    frame.open();
  });

  /* "Use default": put the design's value back */
  $(document).on('click', '.bbq-reset', function () {
    var field = $(this).closest('.bbq-field');
    var d;
    try { d = JSON.parse(this.getAttribute('data-default')); } catch (e) { d = ''; } // jQuery .data() leaves JSON strings quoted
    if (field.hasClass('bbq-field--image')) {
      field.find('input[type=hidden]').val('');
      field.find('img').attr('src', d && d.src ? d.src : '');
    } else if (field.hasClass('bbq-field--link')) {
      d = d || {};
      field.find('input[name$="[label]"]').val(d.label || '');
      field.find('input[name$="[url]"]').val(d.url || '');
      field.find('input[type=checkbox]').prop('checked', !!d.new_tab);
    } else if (field.hasClass('bbq-field--toggle')) {
      field.find('input[type=checkbox]').prop('checked', !!d);
    } else {
      field.find('input[type=text], textarea, select').first().val(d == null ? '' : d);
    }
    field.removeClass('is-changed');
  });

  $(document).on('input change', '.bbq-field input, .bbq-field textarea, .bbq-field select', function () { markChanged(this); });

  /* Repeatable rows */
  function renumber(rows) {
    rows.find('> .bbq-rows__list > [data-bbq-row]').each(function (i) {
      $(this).find('> .bbq-row__bar .bbq-row__num').text(i + 1);
    });
  }
  var uid = 0;
  $(document).on('click', '[data-bbq-add]', function () {
    var rows = $(this).closest('[data-bbq-rows]');
    var tpl = rows.children('template')[0];
    var html = tpl.innerHTML.split('__ROW__').join('n' + Date.now() + '_' + (uid++));
    var row = $(html).appendTo(rows.children('.bbq-rows__list'));
    renumber(rows);
    row.find('input[type=text], textarea').first().trigger('focus');
  });
  $(document).on('click', '[data-bbq-remove]', function () {
    var rows = $(this).closest('[data-bbq-rows]');
    $(this).closest('[data-bbq-row]').remove();
    renumber(rows);
  });
  $(document).on('click', '[data-bbq-up]', function () {
    var row = $(this).closest('[data-bbq-row]');
    row.prev('[data-bbq-row]').before(row);
    renumber(row.closest('[data-bbq-rows]'));
  });
  $(document).on('click', '[data-bbq-down]', function () {
    var row = $(this).closest('[data-bbq-row]');
    row.next('[data-bbq-row]').after(row);
    renumber(row.closest('[data-bbq-rows]'));
  });
  $(document).on('click', '.bbq-reset-rows', function () {
    if (!window.confirm($(this).data('confirm'))) return;
    var rows = $(this).closest('[data-bbq-rows]');
    rows.find('[data-bbq-rows-reset]').val('1');
    rows.addClass('is-reset');
  });
  /* Row title follows its first text field */
  $(document).on('input', '[data-bbq-row] .bbq-row__fields input[type=text], [data-bbq-row] .bbq-row__fields textarea', function () {
    var row = $(this).closest('[data-bbq-row]');
    var first = row.find('.bbq-row__fields input[type=text], .bbq-row__fields textarea').first();
    if (first[0] === this) row.find('> .bbq-row__bar .bbq-row__title').text(this.value.split(/\s+/).slice(0, 8).join(' '));
  });

  /* Open / close all sections */
  $(document).on('click', '[data-bbq-expand]', function () { $(this).closest('.bbq-fields').find('details.bbq-section').attr('open', ''); });
  $(document).on('click', '[data-bbq-collapse]', function () { $(this).closest('.bbq-fields').find('details.bbq-section').removeAttr('open'); });
})(jQuery);
