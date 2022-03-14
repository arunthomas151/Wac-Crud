<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeMailAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;

    }

    /**
     * modified by adarshepep@gmail.com on 14/03/2022
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('employee.mail')->with([
            'name' => $this->employee->name,
            'email' => $this->employee->email,
            'password' => $this->employee->password,
        ]);
    }
}
