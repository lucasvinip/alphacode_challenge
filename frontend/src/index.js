"use strict";

import {
    post,
    get,
    delByID,
    getByID,
    putByID
} from './util/api.js';
import { phasesApp } from './util/strings.js'
import {
    formatDate,
    notNeedsFormat,
    validations
} from './util/fieldsValidation.js'


$(document).ready(async () => {
    $('.container_button button').click(async () => {
        $('.container_button button').css('background-color', 'var(--primary-color)');

        const jsonData = handleInputsJsonPost();
        await dataPost(jsonData);
        await updateTable();

        setTimeout(() => {
            $('.container_button button').css('background-color', 'var(--third-color)');
        }, 200);
    });

    $('.container_input input').focus(function () {
        $(this).siblings('label').addClass('focused');
    });

    $('.container_input input').blur(function () {
        if ($(this).val() === '') {
            $(this).siblings('label').removeClass('focused');
        }
    });
    await updateTable();

    $('table').on('click', 'button.delete', async function () {
        const id = $(this).closest('tr').data('user-id');
        const deleteConfirm = window.confirm(phasesApp.Sure_Exclude_User);

        if (deleteConfirm) {
            const deleteResponse = await delByID(id);
            if (deleteResponse.statusCode === 201) {
                $(this).closest('tr').remove();
                alert(phasesApp.User_Deleted);
            }
            else
                alert(phasesApp.Error_Exclude_User);
        }
        else
            alert(phasesApp.User_Not_Deleted);
    });

    $('table').on('click', 'button.edit', function () {
        const id = $(this).closest('tr').data('user-id');

        handleModalEdit(id);

        $('#editModal').css('display', 'block');
    });

    $('#closeEditModal').click(() => {
        $('#editModal').css('display', 'none');
    });

});

function handleInputsJsonPost() {
    const name = $('#name').val();
    const date_of_birth = $('#date_of_birth').val();
    const email = $('#email').val();
    const contact_phone = $('#contact_phone').val();
    const occupation = $('#occupation').val();
    const contact_cellphone = $('#contact_cellphone').val();

    validations(name, date_of_birth, email, contact_cellphone, contact_phone, occupation)

    const json = {
        name: name,
        date_of_birth: date_of_birth,
        email: email,
        contact_phone: contact_phone,
        occupation: occupation,
        contact_cellphone: contact_cellphone
    };

    return json;
}

const dataPost = async (body) => {
    try {
        const data = await post(body);

        if (data.statusCode == 201) {
            alert(phasesApp.User_Created);

            $('#name').val('');
            $('#date_of_birth').val('');
            $('#email').val('');
            $('#contact_phone').val('');
            $('#occupation').val('');
            $('#contact_cellphone').val('');
        }
        else
            alert(phasesApp.Error_Create_User);

    } catch (error) {
        alert(phasesApp.Error_Request);
    }
}

const updateTable = async () => {
    $('table tbody').empty();

    const data = await dataGet();
    data.forEach((user) => {
        addTableRow(user);
    });
};

const addTableRow = (user) => {
    const formattedDateOfBirth = notNeedsFormat(user.date_of_birth)
        ? formatDate(user.date_of_birth)
        : user.date_of_birth;

    const newRow = `
        <tr data-user-id="${user.id}">
            <td>${user.name}</td>
            <td>${formattedDateOfBirth}</td>
            <td>${user.email}</td>
            <td>${user.contact_cellphone}</td>
            <td class="actions">
                <button class="edit">
                    <img src="public/assets/img/editar.png" alt="button_edit">
                </button>
                <button class="delete">
                    <img src="public/assets/img/excluir.png" alt="delete">
                </button>
            </td>
        </tr>
    `;
    $('table tbody').append(newRow);
};

const dataGet = async () => {
    const data = await get();
    return data.slice().reverse();
};

const handleModalEdit = async (id) => {
    try {
        handleInputsFilledEdit(id);

        $('#editSubmit').click(async (event) => {

            $('#editSubmit').css('background-color', 'var(--primary-color)');
            event.preventDefault();

            const jsonData = handleInputsJsonEdit();

            const updateResponse = await putByID(id, jsonData);

            if (updateResponse.statusCode == 201) {
                alert(phasesApp.Success_Edit_User);
                $('#editModal').css('display', 'none');
                await updateTable()
            }
            else
                alert(phasesApp.Error_Edit_User)
        });
    } catch (error) {
        alert(phasesApp.Error_Get_Data_User);
        $('#editModal').css('display', 'none');
    }
};

const handleInputsJsonEdit = () => {
    const editedUser = {
        name: $('#editName').val(),
        date_of_birth: $('#editDateOfBirth').val(),
        email: $('#editEmail').val(),
        contact_cellphone: $('#editContactCellphone').val(),
    };

    return editedUser;
}

const handleInputsFilledEdit = async (id) => {
    const user = await getByID(id);

    $('#editName').val(user.name);
    $('#editDateOfBirth').val(user.date_of_birth);
    $('#editEmail').val(user.email);
    $('#editContactCellphone').val(user.contact_cellphone);
}


