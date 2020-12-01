import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { UserService } from '../_services';
import { environment } from '../../environments/environment';
import { User } from '../_models';

@Injectable()
export class AuthGuard implements CanActivate {

    constructor(private router: Router, private userService: UserService, ) { }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (localStorage.getItem('currentUser')) {
            // logged in so return true
            this.userService.checkToken()
                .pipe()
                .subscribe(
                    data => {

                        if (data["error"]) {
                            localStorage.removeItem('currentUser');
                            this.router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
                            return false;
                        }
                        else {
                            return true;
                        }
                    },
                    error => {
                        localStorage.removeItem('currentUser');
                        this.router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
                        return false;
                    });

            return true;
        }

        // not logged in so redirect to login page with the return url
        this.router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
        return false;
    }
}