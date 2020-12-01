import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { environment } from '../../environments/environment';
import { User } from '../_models';

@Injectable()
export class UserService {
    constructor(private http: HttpClient) { }

   /* getAll() {
        return this.http.get<User[]>(`${environment.apiUrl}/users`);
    }*/

    /*getById(id: number) {
        return this.http.get(`${environment.apiUrl}/users/` + id);
    }*/

    register(user: User) {
        return this.http.post(`${environment.apiUrl}/user/create.php`, user);
    }

    
    changePass(password: string) {
        return this.http.post(`${environment.apiUrl}/user/resetPass.php`, password);
    }

    changeEmail(email: string) {
        return this.http.post(`${environment.apiUrl}/user/resetEmail.php`, email);
    }

    generateToken(user: string) {
        return this.http.post(`${environment.apiUrl}/user/passToken.php`, user);
    }

    changePassToken(password: string, token: string) {
        return this.http.post(`${environment.apiUrl}/user/resetPassToken.php`, {password: password, token: token});
    }

    checkToken() {
        return this.http.post(`${environment.apiUrl}/user/checktoken.php`,'');
    }
}