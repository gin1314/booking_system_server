@extends('layout3')

@section('content')
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td class="content-block">
                  Hello {{ $booking->first_name }} {{ $booking->last_name }},
                </td>
              <tr>
                <td class="content-block">
                    You have placed a pending bookin for land survey to us
                </td>
              </tr>
              <tr>
                <td class="content-block">
                  <table>
                    <tbody>
                      <tr>
                        <td>Booking Schedule</td>
                        <td>-</td>
                        <td>{{ $bookingSchedule  }} {{ $booking->time_slot_word  }}</td>
                      </tr>
                      <tr>
                        <td>Address of survey land</td>
                        <td>-</td>
                        <td>{{ $addressOfSurveyLand  }}<td>
                      </tr>
                      <tr>
                        <td>Client contact no.</td>
                        <td>-</td>
                        <td>{{ $booking->phone_no  }}<td>
                      </tr>
                      <tr>
                        <td>Clients available requirements</td>
                        <td>-</td>
                        <td>{{ $requirements }}<td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="content-block">
                    <a href="{{$appBaseUrl}}/booking/details/{{$booking->id}}" class="btn-primary">Click here to view Booking details</a>
                </td>
              </tr>
              <tr>
                <td class="content-block">
                  Have a great day!
                </td>
              </tr>
              <tr>
                <td class="content-block">
                  The JBS Land Surveying Team
                </td>
              </tr>
            </table>
@endsection