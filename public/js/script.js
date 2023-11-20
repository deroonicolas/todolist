function toggleTask(taskId, isDone) {
  $.ajax({
    url: '/tasks/' + taskId + '/toggle',
    method: 'GET',
    data: {
      'id': taskId,
      'isDone': isDone
    }
  }).done(function (responseId) {
    const taskButton = $('#task' + responseId)
    const portlet = taskButton.closest('.portlet')
    if (isDone) {
      taskButton.text('Marquer comme faite')
      taskButton.attr('onclick', 'toggleTask(' + responseId + ', 0)')
      portlet.addClass('bg-white').removeClass('bg-info')
      alert('La tâche a bien été marquée comme à faire')
    } else {
      taskButton.text('Marquer comme à faire')
      taskButton.attr('onclick', 'toggleTask(' + responseId + ', 1)')
      portlet.addClass('bg-info').removeClass('bg-white')
      alert('La tâche a bien été marquée comme faite')
    }
  }).fail(function (response) {
    alert("Une erreur est survenue lors de l'édition de la tâche")
  })
}

/*
 Add 'form-control' classe for the default twig forms
 */
 const forms = document.querySelectorAll('form')

 if ((forms.length !== 0) && (forms !== null)) {
   forms.forEach(form => {
     if (form != null) {
       const inputs = form.querySelectorAll('div > input')
       inputs.forEach(element => {
         element.classList.add('class')
         element.setAttribute('class', 'form-control')
       })
     }
   })
 }