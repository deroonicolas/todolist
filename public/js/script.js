$(function () {
  $('.column').sortable({
    connectWith: ".column",
    handle: ".portlet-header",
  })

  $('.portlet').on('mouseup', function (event) {
    const portlet = $(this)
    const taskId = portlet.attr('id')
    if (portlet.parent().hasClass('todo')) {
      // portlet.removeClass('bg-info').addClass('bg-white')
      toggleTask(taskId, 1)
    } else {
      // portlet.removeClass('bg-white').addClass('bg-info')
      toggleTask(taskId, 0)
    }
  })

  // $( ".portlet" )
  //   .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
  //   .find( ".portlet-header" )
  //     .addClass( "ui-widget-header ui-corner-all" )


  // $( ".portlet-toggle" ).on('click', function() {
  //   var icon = $( this );
  //   icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
  //   icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
  // });

})

function toggleTask(taskId, isDone) {
  $.ajax({
    url: '/tasks/' + taskId + '/toggle',
    method: 'GET',
    data: {
      'id': taskId,
      'isDone': isDone
    }
  }).done(function (response) {
    console.log(response)
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