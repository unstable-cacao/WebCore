## Methods
There are no non static methods in this class.

<br>

## Static Methods

#### get(): IInput
Return an implementation of *IInput* that encapsulates the values of the $_GET global variable.

<br>

#### post(): IInput
Return an implementation of *IInput* that encapsulates the values of the $_POST global variable.

<br>

#### cookies(): IInput
Return an implementation of *IInput* that encapsulates the values of the $_COOKIE global variable.

<br>

#### headers(): IInput
Return an implementation of *IInput* that encapsulates all found headers passed to $_SERVER.

<br>

#### session(): IInput
Return an implementation of *IInput* that encapsulates the values of the $_SESSION global variable.
If session does not exist, *IInput* implementation receives an empty array.

<br>

#### params(): IInput
Return an implementation of *IInput* that is initialized with values based on the current request Method. See table:
| Method  | Initialized with                                     |
|---------|------------------------------------------------------|
| GET     | $_GET                                                |
| OPTIONS | $_GET                                                |
| HEAD    | $_GET                                                |
| DELETE  | $_GET                                                |
| POST    | $_POST                                               |
| PUT     | array of parsed parameters from the raw request body |
| UNKNOWN | empty array                                          |

<br>

#### body(): string
Return the raw request body as string.

<br>

#### method(): string
Return one of *Method* constants, according to request method.

<br>

#### is(string $method): bool
Return true if given string is the method of the request.

<br>

#### isGet(): bool
Return true if request method is GET.

<br>

#### isHead(): bool
Return true if request method is HEAD.

<br>

#### isPost(): bool
Return true if request method is POST.

<br>

#### isPut(): bool
Return true if request method is PUT.

<br>

#### isDelete(): bool
Return true if request method is DELETE.

<br>

#### isOptions(): bool
Return true if request method is OPTIONS.