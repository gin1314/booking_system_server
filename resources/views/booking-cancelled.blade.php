@extends('layout3')

@section('content')
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td class="content-block">
                  Hello Admin {{ $user->name }},
                </td>
              <tr>
                <td class="content-block">
                    A survey booking has been cancelled by {{ $user->name }}
                </td>
              </tr>
              <tr>
                <td class="content-block">
                  <table>
                    <tbody>
                      <tr>
                        <td>Survey Engineer</td>
                        <td>-</td>
                        <td>{{ $user->name }}</td>
                      </tr>
                      <tr>
                        <td>Engineer Contact no.</td>
                        <td>-</td>
                        <td>{{ $user->phone_no }}</td>
                      </tr>
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