
function csrfSafeMethod(method) {
  return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method))
}

var csrftoken = document.querySelector('meta[name~="csrf-token"]').getAttribute('content')

axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRFTOKEN': csrftoken
}
