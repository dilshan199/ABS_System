$(document).ready(function() {
    var advancedEditor = new SimpleTableCellEditor("etitableTable");
    advancedEditor.SetEditableClass("itemNo", { validation: $.isNumeric });
    advancedEditor.SetEditableClass("item");
    advancedEditor.SetEditableClass("amount");
    // advancedEditor.SetEditableClass("cat_id", {
    //     internals: {
    //         renderEditor: (elem, oldVal) => {
    //             $(elem).html(`<select>
    //                 <option>Pain au chocolat</option>
    //                 <option>Chocolatine</option>
    //                 </select>`);

    //                 $("select option").filter(function () {
    //                     return $(this).val() == oldVal;
    //                 }).prop('selected', true);

    //             },
    //             extractEditorValue: (elem) => { return $(elem).find('select').val(); },

    //     }
    // });
});
