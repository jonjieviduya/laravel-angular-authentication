import { Component, OnInit } from '@angular/core';
import { HttpRequestService } from 'src/app/Services/http-request.service';
import { SnotifyService } from 'ng-snotify';

@Component({
  selector: 'app-request-reset',
  templateUrl: './request-reset.component.html',
  styleUrls: ['./request-reset.component.css']
})
export class RequestResetComponent implements OnInit {

  public form = {
    email: null
  };

  constructor(
    private HttpRequest: HttpRequestService,
    private notify: SnotifyService
  ) { }

  ngOnInit(): void {
  }

  onSubmit(){
    this.notify.info('Wait...', {timeout: 5000});
    this.HttpRequest.sendPasswordResetLink(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.notify.error(error.error.error)
    );
  }
 
  handleResponse(response){
    this.notify.success(response.data, {timeout: 0});
    this.form.email = null;
  }

}
