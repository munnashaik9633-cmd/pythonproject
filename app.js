document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-fill-user]').forEach(button => {
    button.addEventListener('click', () => {
      const form = button.closest('.auth-panel');
      form.querySelector('input[name="username"]').value = button.dataset.fillUser;
      form.querySelector('input[name="password"]').value = button.dataset.fillPass;
      const role = button.dataset.fillUser === 'admin' ? 'admin' : button.dataset.fillUser;
      const radio = form.querySelector(`input[name="role"][value="${role}"]`);
      if (radio) { radio.checked = true; radio.dispatchEvent(new Event('change')); }
    });
  });
  document.querySelectorAll('input[name="role"]').forEach(radio => radio.addEventListener('change', () => {
    const label = document.getElementById('role-label');
    if (label) label.textContent = radio.value;
  }));
});
