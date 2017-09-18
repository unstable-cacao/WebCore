####get(): IInput
Return *IInput* sourced from $_GET.

<br>

####post(): IInput
Return *IInput* sourced from $_POST.

<br>

####cookies(): IInput
Return *IInput* sourced from $_COOKIE.

<br>

####headers(): IInput
Return *IInput* containing all delivered request headers.

<br>

####session(): IInput
Return *IInput* sourced from $_SESSION. 
If session does not exist, *IInput* sourced from empty array.

<br>

####params(): IInput
Return *IInput* sourced from:
 * $_GET for methods GET, OPTIONS, HEAD, DELETE
 * $_POST for method POST
 * request body for method PUT
 * empty array for UNKNOWN method

<br>

####body(): string
Return the raw body of the request.

<br>

####method(): string
Return one of *Method* constants, according to request method.

<br>

####is(string $method): bool
Return true if given string is the method of the request.

<br>

####isGet(): bool
Return true if request method is GET.

<br>

####isHead(): bool
Return true if request method is HEAD.

<br>

####isPost(): bool
Return true if request method is POST.

<br>

####isPut(): bool
Return true if request method is PUT.

<br>

####isDelete(): bool
Return true if request method is DELETE.

<br>

####isOptions(): bool
Return true if request method is OPTIONS.