<?php

namespace App\Models;

use App\Support\model\GetThesisReqModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thesis extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'thesis';

    protected $fillable = [
        'topic_id',
        'type_id',
        'lecturer_id',
        'student_id',
        'title',
        'abstract',
        'download_count',
        'submission_status',
        'note',
        'created_at',
        'updated_at'
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ThesisTopic::class, 'topic_id', 'id');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ThesisType::class, 'type_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ThesisFile::class, "thesis_id", "id")->orderBy('sequence_num', 'asc');
    }

    public function scopeDashboardFilter(Builder $query, GetThesisReqModel $reqModel)
    {
        return $query->where('submission_status', true)
            ->when($reqModel->publicationYear, function ($query) use ($reqModel) {
                return $query->whereRaw('YEAR(created_at) = ?', [$reqModel->publicationYear]);
            })
            ->when($reqModel->studentClassYear, function ($query) use ($reqModel) {
                return $query->whereRelation('student', 'class_year', $reqModel->studentClassYear);
            })
            ->when($reqModel->programStudyID, function ($query) use ($reqModel) {
                return $query->whereRelation('student.programStudy', 'id', $reqModel->programStudyID);
            })
            ->when($reqModel->topicID, function ($query) use ($reqModel) {
                return $query->whereRelation('topic', 'id', $reqModel->topicID);
            })
            ->when($reqModel->lecturerID, function ($query) use ($reqModel) {
                return $query->where('lecturer_id', $reqModel->lecturerID);
            })
            ->when($reqModel->typeID, function ($query) use ($reqModel) {
                return is_array($reqModel->typeID) ? $query->whereIn('tte.id', $reqModel->typeID) : $query->where('tte.id', $reqModel->typeID);
            });
    }

    public function scopeDashboardDataQuery(Builder $query, GetThesisReqModel $reqModel)
    {
        return $query->from('thesis as t')->where('t.submission_status', true)
            ->when($reqModel->studentClassYear, function ($query) use ($reqModel) {
                return $query->where('s.class_year', $reqModel->studentClassYear);
            })
            ->when($reqModel->topicID, function ($query) use ($reqModel) {
                return is_array($reqModel->topicID) ? $query->whereIn('t.topic_id', $reqModel->topicID) : $query->where('t.topic_id', $reqModel->topicID);
            })
            ->when($reqModel->programStudyID, function ($query) use ($reqModel) {
                return is_array($reqModel->programStudyID) ? $query->whereIn('s.program_study_id', $reqModel->programStudyID) : $query->where('s.program_study_id', $reqModel->programStudyID);
            })
            ->when($reqModel->lecturerID, function ($query) use ($reqModel) {
                return $query->where('t.lecturer_id', $reqModel->lecturerID);
            })
            ->when($reqModel->typeID, function ($query) use ($reqModel) {
                return is_array($reqModel->typeID) ? $query->whereIn('tte.id', $reqModel->typeID) : $query->where('tte.id', $reqModel->typeID);
            })
            ->when($reqModel->publicationYear, function ($query) use ($reqModel) {
                return $query->whereRaw('YEAR(t.created_at) = ?', [$reqModel->publicationYear]);
            })
            ->join('students as s', 's.id', 't.student_id')
            ->join('program_study as ps', 'ps.id', 's.program_study_id')
            ->join('thesis_topics as tt', 'tt.id', 't.topic_id')
            ->join('thesis_types as tte', 'tte.id', 't.type_id')
            ->join('lecturers as l', 'l.id', 't.lecturer_id')
            ->selectRaw('t.id as thesis_id, t.student_id, t.submission_status, s.username, s.program_study_id, ps.name as program_study_name, t.topic_id, tt.topic as thesis_topic, Year(t.created_at) as publication_year, tte.id as thesis_type_id, tte.type as thesis_type, t.lecturer_id, l.name as lecturer_name, s.class_year, s.gender')
            ->orderBy('t.id', 'DESC');
    }
}
