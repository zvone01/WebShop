import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-page3',
  templateUrl: './page3.component.html',
  styleUrls: ['./page3.component.css']
})
export class Page3Component implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }

  singleperson()
	{
		localStorage.removeItem('multiplyByPeopleNum');
		this.router.navigate(['/shop/1']);
  }
  
  multiperson()
	{
		localStorage.removeItem('multiplyByPeopleNum');
		localStorage.setItem('multiplyByPeopleNum', "true");
		this.router.navigate(['/shop/1']);
	}

}
