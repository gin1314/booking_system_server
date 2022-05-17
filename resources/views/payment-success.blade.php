@extends('layout3')

@section('content')
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td class="content-block">
                  Hello {{ $booking->first_name }} {{ $booking->last_name }},
                </td>
              <tr>
                <td class="content-block">
                  Thank you for trusting our company. Your booking and survey process is done. Wait for the further notice about releasing of the survey plan approval from DENR.
                </td>
              </tr>
              <tr>
                <td class="content-block">
                  Your processing time will be estimated to perform within 30 working days.
                </td>
              </tr>
              <tr>
                <td class="content-block">
                    If you have any questions, please contact us
                </td>
              </tr>
              {{-- <tr>
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
              </tr> --}}
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