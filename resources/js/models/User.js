export default class User {
    constructor(
        id = '',
        rut = '',
        name = '',
        lastname = '',
        motherLastname = '',
        phone = '',
        email = '',
        password = ''
    ) {
        this.id = id;
        this.rut = rut;
        this.name = name;
        lastname = lastname;
        phone = phone;
        motherLastname = motherLastname;
        this.email = email;
        this.password = password;
    }
}
