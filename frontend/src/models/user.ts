export default class User {
    email : String;
    password : String;
    firstname : String;
    lastname : String;
    phone_number : String;
    type : String;

    constructor(email : String, password : String, firstname : String, lastname : String, phone_number : String, type : String) {
      this.email = email;
      this.password = password;
      this.firstname = firstname;
      this.lastname = lastname;
      this.phone_number = phone_number;
      this.type = type;
    }
  }