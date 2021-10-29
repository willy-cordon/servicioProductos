$(function () {
    $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('.to-select2')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
    })
    $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('.to-select2')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
    })

    $('.to-select2').select2()
})

