export default class User {
    constructor(
        id = '',
        rut = '',
        name = '',
        lastname = '',
        motherLastname = '',
        email = '',
        password = ''
    ) {
        this.id = id;
        this.rut = rut;
        this.name = name;
        lastname = lastname;
        motherLastname = motherLastname;
        this.email = email;
        this.password = password;
    }
}
