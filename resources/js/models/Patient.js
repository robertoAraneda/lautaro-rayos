export default class Patient {
    constructor(
        id = '',
        rut = '',
        bdup = '',
        names = '',
        lastname = '',
        motherLastname = '',
        birthDate = '',
        email = '',
        phone = '',
        age = ''
    ) {
        this.id = id;
        this.rut = rut;
        this.bdup = bdup;
        this.names = names;
        this.lastname = lastname;
        this.motherLastname = motherLastname;
        this.birthDate = birthDate;
        this.email = email;
        this.phone = phone;
        this.age = age;
    }
}
