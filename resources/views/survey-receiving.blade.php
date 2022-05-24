@extends('layout3')

@section('content')
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td class="content-block">
                  Hello {{ $booking->first_name }} {{ $booking->last_name }},
                </td>
              <tr>
                <td class="content-block">
                  Thank you for trusting our company. Your papers are done processing kindly visit our office at Unit H, 2nd Floor F & P Bldg. (Infront of Taguig City Hall) Gen. Luna st. Tuktukan Taguig City
                </td>
              </tr>
              @if(!empty($remark))
                <tr>
                  <td class="content-block">
                    <b>Remarks:</b>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 0 20px 20px 20px;" class="content-block">
                    {{ $remark }}
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                      If you have any questions, please contact us
                  </td>
                </tr>
              @endif

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