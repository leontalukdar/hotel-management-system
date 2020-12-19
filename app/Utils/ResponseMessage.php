<?php


namespace App\Utils;


class ResponseMessage
{
    const INVALID_CREDENTIALS = 'Invalid email or password';
    const AUTHENTICATION_ERROR = "Jwt autentication error";
    const INVALID_REQUEST = 'Invalid request format';
    const REGISTRATION_SUCCESS = "Registration successfull";
    const LOGIN_SUCCESS = "Successfully logged in";
    const ROOM_LIST = "Room list";
    const UNAUTHORIZED = "Unauthorized";
    const UNAUTHENTICATED = "Unauthenticated";
    const NOT_FOUND = "Not found";
    const METHOD_NOT_ALLOWED = "Method not allowed";
    const NOT_AVAILABLE = "Room already booked or not available";
    const BOOK_SUCCESS = "Booking information";
    const SERVER_ERROR = "Internal server error";
    const PAYMENT_ERROR = "Plese clear your all dues to checkout";
    const CHECKOUT_SUCCESS = "Customer successfully checked out";
    const BOOKING_LIST = "Booking list";
}
