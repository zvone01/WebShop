import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService, AuthenticationService, UserService } from '../_services';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-reset-pass',
  templateUrl: './reset-pass.component.html',
  styleUrls: ['./reset-pass.component.css']
})
export class ResetPassComponent implements OnInit {

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

    this.newPassForm = this.formBuilder.group({
      Email: ['', [Validators.required, Validators.email]]
    });

  }

  get f() { return this.newPassForm.controls; }

  onSubmit() {
    this.submitted = true;
    if (this.newPassForm.invalid) {
      return;
    }

    this.loading = true;

    this.userService.generateToken(this.newPassForm.value)
      .subscribe(
        data => {
            this.alertService.success(data['message'] + ", Check your email for password reset");
        } ,
      error => {
          this.alertService.error(error.error.message);
      });
   }

}
