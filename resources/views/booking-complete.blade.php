@extends('layout3')

@section('content')
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td class="content-block">
                  Hello {{ $booking->first_name }} {{ $booking->last_name }},
                </td>
              <tr>
                <td class="content-block">
                    Your booking has been been completed by {{ $booking->user->name }}
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
                        <td>Contact no.</td>
                        <td>-</td>
                        <td>{{ $user->phone_no }}</td>
                      </tr>
                      <tr>
                        <td>Survey Schedult</td>
                        <td>-</td>
                        <td></td>
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