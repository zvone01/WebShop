import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService, AuthenticationService, UserService } from '../_services';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-user-admin',
  templateUrl: './user-admin.component.html',
  styleUrls: ['./user-admin.component.css']
})
export class UserAdminComponent implements OnInit {

  newPassForm: FormGroup;
  newEmailForm: FormGroup;
  loading = false;
  submittedEmail = false;
  submittedPass = false;

  constructor(   private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authenticationService: AuthenticationService,
    private userService: UserService,
    private alertService: AlertService) { }


    ngOnInit() {
      this.newEmailForm = this.formBuilder.group({
        Email: ['',[ Validators.email,  Validators.required]]
      });

      this.newPassForm = this.formBuilder.group({
        Password: ['', Validators.required]
    });

  }

  get fp() { return this.newPassForm.controls; }

  get fe() { return this.newEmailForm.controls; }

  onSubmit() {
    this.submittedPass = true;
    
    // stop here if form is invalid
    if (this.newPassForm.invalid) {
        return;
    }

    this.loading = true;

    this.userService.changePass(this.newPassForm.value)
    .subscribe(
      
      data => {
        this.alertService.success(data["message"]);

      },
      error => {
        this.alertService.error(error);
        this.loading = false;

      }) ;
}

onSubmitEmail() {
  this.submittedEmail = true;
  
  // stop here if form is invalid
  if (this.newEmailForm.invalid) {
      return;
  }

  this.loading = true;

  this.userService.changeEmail(this.newEmailForm.value)
  .subscribe(
    
    data => {
      this.alertService.success(data["message"]);

    },
    error => {
      this.alertService.error(error);
      this.loading = false;

    }) ;
}


}
