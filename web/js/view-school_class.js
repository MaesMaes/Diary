// $(function() {
//     $('input[name="selection[]"]').on('change', function() {
//         var pupilId = $(this).val();
//         var checked = $(this).prop("checked");
//         var schoolClassId = $(this).prop("school_class_id");
//
//         $.ajax({
//             url: 'school-class/pupilDataUpdate',
//             method: 'POST',
//             data: {
//                 pupilId: pupilId,
//                 checked: checked,
//                 schoolClassId: schoolClassId
//             },
//             success: function(data) {
//                 console.log('data');
//             }
//         });
//     });
// });