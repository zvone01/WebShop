import { Component } from '@angular/core';
import { OnInit } from '@angular/core';
declare var $: any;
import { Router } from '@angular/router';
import { FormBuilder, RequiredValidator } from '@angular/forms';
import { FormGroup } from '@angular/forms';
import { Validators } from '@angular/forms';
@Component({
	selector: 'angly-home',
	templateUrl: './home.component.html',
	styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

	resnumform: FormGroup;
	submitted = false;

	constructor(
		private formBuilder: FormBuilder,
		private router: Router) {
	}

	ngOnInit() {
		this.resnumform = this.formBuilder.group({
			resnum: ['', Validators.required],
		});
	}


	// convenience getter for easy access to form fields
	get f() { return this.resnumform.controls; }

	onSubmit() {
		this.submitted= true;
		//console.log("res num");
		// stop here if form is invalid
		if (this.resnumform.invalid ) {
			return;
		}

		localStorage.removeItem('selectionType');
		localStorage.setItem('selectionType', "reservationCode");
		localStorage.setItem('reservationCode', this.resnumform.value.resnum);

		this.router.navigate(['/shop/1']);
	}

	dateAndMeal()
	{
		localStorage.removeItem('selectionType');
		localStorage.setItem('selectionType', "dateAndMeal");
		this.router.navigate(['/date']);
	}

	onlyDate(){
		localStorage.removeItem('selectionType');
		localStorage.setItem('selectionType', "meal");
		this.router.navigate(['/date']);
	}
}
