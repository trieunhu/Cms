/*jslint browser: true, devel: true, white: true, eqeq: true, plusplus: true, sloppy: true, vars: true*/
/*global $ */

/*************** General ***************/

var updateOutput = function (e) {
    var list = e.length ? e : $(e.target),
            output = list.data('output');
            console.log(list);
    datajson = '';
    if (window.JSON) {
        if (output) {
            console.log(output);
            datajson = window.JSON.stringify(list.nestable('serialize'));
            output.val(window.JSON.stringify(list.nestable('serialize')));
            $('#id_json_value').val(datajson);
        }
    } else {
        alert('JSON browser support required for this page.');
    }
    return datajson;
};

var nestableList = $("#nestable > .dd-list");

/***************************************/


/*************** Delete ***************/

var deleteFromMenuHelper = function (target) {
    target.fadeOut(function () {
        target.remove();
        updateOutput($('#nestable').data('output', $('#json-output')));
    });
};

var deleteFromMenu = function () {
    var targetId = $(this).data('owner-id');
    var target = $('[data-id="' + targetId + '"]');
    console.log(target);
    var result = confirm("Delete " + target.data('name') + " and all its subitems ?");
    if (!result) {
        return;
    }

    // Remove children (if any)
    target.find("li").each(function () {
        deleteFromMenuHelper($(this));
    });

    // Remove parent
    deleteFromMenuHelper(target);

    // update JSON
    updateOutput($('#nestable').data('output', $('#json-output')));
};

/*************** Edit ***************/

var menuEditor = $("#menu-editor");
var editButton = $("#editButton");
var editInputName = $("#editInputName");
var editInputSlug = $("#editInputSlug");
var currentEditName = $("#currentEditName");

// Prepares and shows the Edit Form
var prepareEdit = function () {
    console.log("a");
    var parent = $(this).parent();
    t = parent;
    var edit = $(parent.find('.edit-form')[0]);
    var i = $(parent.find('i')[0]);
    if (edit.is(':visible')) {
        edit.fadeOut(1000);
        i.removeClass('glyphicon-triangle-top');
        i.addClass('glyphicon-triangle-bottom');
    } else {
        edit.fadeIn(1000);
        i.removeClass('glyphicon-triangle-bottom');
        i.addClass('glyphicon-triangle-top');
    }
};

/***************************************/


/*************** Add ***************/

var newIdCount = $('.dd-item').length;
function addMenu(id, name, type, url) {
    newIdCount++;
    var newId = 'new-' + newIdCount;
    var htmlUrl = '';
    var typeName = type;
    if (type == 'linktinh') {
        htmlUrl = '<div class="form-group no-border">'
                + '<label>Url</label>'
                + '<input type="text" name="textname[]" value="'+url+'"' + ' data-owner-id="' + newIdCount + '" class="form-control input-data-url">'
                + '</div>';
        typeName = "Link tĩnh";
    }
    nestableList.append(
            '<li class="dd-item" ' +
            'data-id="' + newIdCount + '" ' + ' data-newtab="0" ' +
            'data-idpost="' + id + '" ' +
            'data-name="' + name + '" ' +
            'data-type="' + type + '" ' +
            'data-url="' + url + '" ' +
            'data-new="' + newId + '" >' +
            '<div class="dd-handle">' + name + '</div> ' +
            '<span class="button-edit pull-right button-edit' + newId + '" ' +
            'data-owner-id="' + newId + '">' +
            '<p class="titleli">'+typeName +'</p>'+
            '<i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i>' +
            '</span>' +
            '<div class="box no-border edit-form" style="margin-top: -5px;">'
            + '<div class="box-body" style="display: block;">'
            + '<div class="col-md-12 no-padding">'
            + '<div class="form-group no-border">'
            + '<label>Tên hiển thị</label>'
            + '<input type="text" name="textname[]" ' + ' data-owner-id="' + newIdCount + '" value="' + name + '" class="input-data-name form-control">'
            + '</div>'
            + htmlUrl
            + '<div class="checkbox">'
            + '<label><input type="checkbox" class="input-data-tab" ' + ' data-owner-id="' + newIdCount + '" value="">Mở tab mới</label>'
            + '</div>'
            + '<div class="no-border">'
            + '<a class="button-delete' + newId + '" data-owner-id="' + newIdCount + '">Xóa</a>'
            + '</div></div></div></div>'
            + '</li>'
            );



    // update JSON
    updateOutput($('#nestable').data('output', $('#json-output')));

    // set events
    $("#nestable .button-delete" + newId).on("click", deleteFromMenu);
    $("#nestable .button-edit" + newId).on("click", prepareEdit);
}
$(function () {

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#json-output')));

    $("#nestable .button-delete").on("click", deleteFromMenu);

    $("#nestable .button-edit").on("click", prepareEdit);
    $('.select-all').on('click', function () {
        $(this).parents('.tab-pane').find('.checkbox-menu').attr('checked', 'checked');
    })

    $('.add_to_menu').on('click', function () {
        var type = $(this).attr('data-type');
        if (type == 'linktinh') {
            t = $(this);
            var name = $(this).parents('.add-link-tinh').find('.input-data-name').val();
            var url = $(this).parents('.add-link-tinh').find('.input-data-url').val();
            addMenu(0,name,type,url);
            $(this).parents('.add-link-tinh').find('.input-data-name').val("");
            $(this).parents('.add-link-tinh').find('.input-data-url').val("");
        } else {
            $.each($(this).parents('.tab-pane').find('.checkbox-menu:checked'), function (i, value) {
                var id = $(this).val();
                var name = $(this).parent().find('p').html();
                addMenu(id, name, type, '');
            });
        }

    });

    $(document).delegate('.input-data-url', 'keyup', function (e) {
        var targetId = $(this).data('owner-id');
        var target = $('[data-id="' + targetId + '"]');
        target.data('url', $(this).val());
        updateOutput($('#nestable').data('output', $('#json-output')));
    });
    $(document).delegate('.input-data-name', 'keyup', function (e) {
        var targetId = $(this).data('owner-id');
        var target = $('[data-id="' + targetId + '"]');
        target.data('name', $(this).val());
        updateOutput($('#nestable').data('output', $('#json-output')));
    });
    $(document).delegate('.input-data-tab', 'change', function (e) {
        var value = 0;
        if ($(this).prop("checked")) {
            value = 1;
        }
        var targetId = $(this).data('owner-id');
        var target = $('[data-id="' + targetId + '"]');
        target.data('newtab', value);
        updateOutput($('#nestable').data('output', $('#json-output')));
    });
});

