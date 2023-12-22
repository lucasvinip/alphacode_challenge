"use strict"

export const getByID = async (id) => {
    const response = await fetch(`http://localhost:8080/users/${id}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    })
    const data = await response.json()
    return data
};

export const get = async () => {
    const response = await fetch(`http://localhost:8080/users`, {
        headers: {
            "Content-Type": "application/json",
        }
    })
    const data = await response.json()
    return data
};

export const post = async (body) => {
    const response = await fetch(`http://localhost:8080/users`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    })
    const data = await response.json()
    return data
}

export const putByID = async (id, body) => {
    const response = await fetch(`http://localhost:8080/users/${id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    })
    const data = await response.json()
    return data
}

export const delByID = async (id) => {
    const response = await fetch(`http://localhost:8080/users/${id}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        }
    })
    const data = await response.json()
    return data
}