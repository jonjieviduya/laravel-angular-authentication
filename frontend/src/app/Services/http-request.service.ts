import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class HttpRequestService {

  private baseUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) { }

  signup(data){
    return this.http.post(`${this.baseUrl}/signup`, data);
  }

  login(data){
    return this.http.post(`${this.baseUrl}/login`, data);
  }

  sendPasswordResetLink(data){
    return this.http.post(`${this.baseUrl}/send-password-reset-link`, data);
  }

  changePassword(data){
    return this.http.post(`${this.baseUrl}/change-password`, data);
  }

}
