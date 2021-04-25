export default class User {
    constructor(
        id = '',
        rut = '',
        name = '',
        lastname = '',
        motherLastname = '',
        phone = '',
        email = '',
        password = '',
        role = null
    ) {
        this.id = id;
        this.rut = rut;
        this.name = name;
        this.lastname = lastname;
        this.phone = phone;
        this.motherLastname = motherLastname;
        this.email = email;
        this.password = password;
        this.role = role;
    }
}
