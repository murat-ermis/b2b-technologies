<?php

namespace App;

enum OrderStatus: string
{
  case Pending = 'pending';
  case Approved = 'approved';
  case Shipped = 'shipped';
}
