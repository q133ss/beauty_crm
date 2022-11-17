<?php
namespace App\Services\Records;

use App\Models\Record;

class StatusService{
    public static function statusChange(Array $request){

        $record = Record::findOrFail($request['id']);
        if(Auth()->id() == $record->user_id) {
            $record->record_status_id = $request['status_id'];
            $record->save();
            return to_route('records.index')->withSuccess('Заявка успешно принята');
        }
        abort(403, 'У вас нет прав');
    }
}
