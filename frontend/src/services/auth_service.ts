import axios from 'axios';

const API_URL = 'http://localhost/backend/';

export default class AuthService {
  public login(user : any) {
    const formData = new FormData();
    formData.append('email', user.email);
    formData.append('password', user.password);
    return axios
      .post(API_URL + 'accounts/', formData)
      .then(response => {
        if (response.data.jwt) {
          localStorage.setItem("user", JSON.stringify(response.data));
        }

        return response.data;
      });
  }

  logout() {
    localStorage.removeItem('user');
  }

  public register(user : any) {
    const formData = new FormData();
    formData.append('email', user.email);
    formData.append('password', user.password);
    formData.append('first_name', user.firstname);
    formData.append('last_name', user.lastname);
    formData.append('phone_number', user.phone_number);
    formData.append('type', user.type);
    return axios
      .post(API_URL + 'accounts/', formData)
      .then(response => {
      });
  }
  
}