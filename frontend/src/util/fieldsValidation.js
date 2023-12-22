import { phasesApp } from "./strings.js";

export const formatDate = (date_of_birth) => {
    const dateObject = new Date(date_of_birth);
    const day = dateObject.getDate();
    const month = dateObject.getMonth() + 1;
    const year = dateObject.getFullYear();
    return `${(day < 10 ? '0' : '') + day}/${(month < 10 ? '0' : '') + month}/${year}`;
};

export const notNeedsFormat = (date_of_birth) => {
    return /^\d{4}-\d{2}-\d{2}$/.test(date_of_birth);
};

export const isValidDateFormat = (dateString) => {
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    return regex.test(dateString) && !isNaN(Date.parse(dateString));
}

export const isValidPhoneNumber = (phoneNumber) => {
    const regex = /^\d{10,11}$/;
    return regex.test(phoneNumber);
}

export const isValidEmailFormat = (email) => { 
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

export const validations = (name, date_of_birth, email, contact_cellphone, occupation) => {
    if (!name || !date_of_birth || !email || !contact_cellphone) {
        alert(phasesApp.Please_Required_Fields);
        return null;
    }
    const isValidDate = isValidDateFormat(date_of_birth);

    if (!isValidDate) {
        alert(phasesApp.Please_Birth_Validate);
        return null;
    }

    else if(!isValidPhoneNumber(contact_cellphone)){
        alert(phasesApp.Please_Cell_Phone);
        return null;
    }
    
    const isValidEmail = isValidEmailFormat(email);

    if (!isValidEmail) {
        alert(phasesApp.Please_Email_Validate);
        return null;
    }

    if (name.length < 10 || name.length > 30) {
        alert(phasesApp.Please_Name_Max_Min);
        return null;
    }
    else if (occupation.length < 10 || occupation.length > 30) {
        alert(phasesApp.Please_Occupation_Max_Min);
        return null;
    }
}