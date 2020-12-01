import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService, AuthenticationService, UserService } from '../_services';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-reset-pass-menu',
  templateUrl: './reset-pass-menu.component.html',
  styleUrls: ['./reset-pass-menu.component.css']
})
export class ResetPassMenuComponent implements OnInit {

  newPassForm: FormGroup;
  loading = false;
  submitted = false;
  token: string;

  constructor(private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authenticationService: AuthenticationService,
    private userService: UserService,
    private alertService: AlertService) { }


  ngOnInit() {
    this.token = this.route.snapshot.paramMap.get('Token');
    this.newPassForm = this.formBuilder.group({
      Password: ['', Validators.required]
    });

    // reset login status
    // get return url from route parameters or default to '/'
  }

  get f() { return this.newPassForm.controls; }

  onSubmit() {

    this.submitted = true;

    // stop here if form is invalid
    if (this.newPassForm.invalid) {
      return;
    }

    this.loading = true;

    this.userService.changePassToken(this.newPassForm.get('Password').value, this.token)
      .subscribe(

        data => {


        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });
  }


}
