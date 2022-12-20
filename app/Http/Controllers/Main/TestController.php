<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Penyakit;
use App\Models\DetailPenyakit as DetailPenyakitModel;
use App\Models\Gejala as GejalaModel;

class TestController extends Controller
{
    public function step_one()
    {
        $data = session()->get('test_step_1', []);

        $questions = DB::table('gejala')
        ->select([
            'id',
            'name', 
        ])  
        ->inRandomOrder()
        ->get();

        return view('main.step-1', [
            'data' => $data,
            'questions' => $questions
        ]);
    }

    public function post_step_one(Request $request)
    {
        session()->put('test_step_1', $request->all());

        return redirect('/test/step-2');
    }

    public function step_two()
    {
        $data = session()->get('test_step_2', []);

        $questions = DB::table('survey_wellbeing_questions')
            ->select([
                'survey_wellbeing_questions.id',
                'survey_wellbeing_questions.question',
                'survey_wellbeing_questions.answer_from',
                'survey_wellbeing_questions.answer_to'
            ])
            ->leftJoin('survey_wellbeing_question_categories','survey_wellbeing_question_categories.question_id','=','survey_wellbeing_questions.id')
            ->leftJoin('survey_wellbeing_categories','survey_wellbeing_categories.id','=','survey_wellbeing_question_categories.category_id')
            ->where('survey_wellbeing_categories.type', 1)
            ->whereNull('survey_wellbeing_questions.deleted_at')
            ->distinct('survey_wellbeing_questions.id')
            ->inRandomOrder()
            ->get();

        return view('main.test.step-2', [
            'data' => $data,
            'questions' => $questions
        ]);
    }

    public function post_step_two(Request $request)
    {
        session()->put('test_step_2', $request->all());

        return redirect('/test/step-3');
    }

    public function step_three()
    {
        $data = session()->get('test_step_3', []);

        $questions = DB::table('survey_wellbeing_questions')
            ->select([
                'survey_wellbeing_questions.id',
                'survey_wellbeing_questions.question',
                'survey_wellbeing_questions.answer_from',
                'survey_wellbeing_questions.answer_to'
            ])
            ->leftJoin('survey_wellbeing_question_categories','survey_wellbeing_question_categories.question_id','=','survey_wellbeing_questions.id')
            ->leftJoin('survey_wellbeing_categories','survey_wellbeing_categories.id','=','survey_wellbeing_question_categories.category_id')
            ->where('survey_wellbeing_categories.type', 2)
            ->where('survey_wellbeing_questions.type', 0)
            ->whereNull('survey_wellbeing_questions.deleted_at')
            ->distinct('survey_wellbeing_questions.id')
            ->inRandomOrder()
            ->get(); 

        return view('main.test.step-3', [
            'data' => $data,
            'questions' => $questions, 
        ]);
    }

    public function post_step_three(Request $request)
    {
        session()->put('test_step_3', $request->all());
   
        return redirect('/test/step-4');
    }

    public function step_four()
    {
        $data = session()->get('test_step_4', []);
  
        $ptsd = DB::table('survey_wellbeing_questions')
            ->select([
                'survey_wellbeing_questions.id',
                'survey_wellbeing_questions.question',
                'survey_wellbeing_questions.answer_from',
                'survey_wellbeing_questions.answer_to'
            ])
            ->leftJoin('survey_wellbeing_question_categories','survey_wellbeing_question_categories.question_id','=','survey_wellbeing_questions.id')
            ->leftJoin('survey_wellbeing_categories','survey_wellbeing_categories.id','=','survey_wellbeing_question_categories.category_id')
            ->where('survey_wellbeing_categories.type', 2)
            ->where('survey_wellbeing_questions.type', 2)
            ->whereNull('survey_wellbeing_questions.deleted_at')
            ->distinct('survey_wellbeing_questions.id')
            ->inRandomOrder()
            ->get();

        return view('main.test.step-4', [
            'data' => $data, 
            'ptsd' => $ptsd
        ]);
    }

    public function post_step_four(Request $request)
    {
        session()->put('test_step_4', $request->all());

        DB::transaction(function () { 
            $data_test_step_1 = session()->get('test_step_1', []);
            $data_test_step_2 = session()->get('test_step_2', []);
            $data_test_step_3 = session()->get('test_step_3', []);
            $data_test_step_4 = session()->get('test_step_4', []);
             
            $respondent = Respondent::create([ 
                'name' => $data_test_step_1['name'],
                'age' => $data_test_step_1['age'],
                'gender' => $data_test_step_1['gender'],
                'address' => $data_test_step_1['address'],
                'phone' => $data_test_step_1['phone'],
                'office_email' => $data_test_step_1['office_email'],
                'instansi' => $data_test_step_1['instansi']
            ]);

            $date_answer = DateAnswer::create([
                'respondent_id' => $respondent->id,
                'date' => date('Y-m-d')
            ]);

            foreach ($data_test_step_2 as $key => $answer) {
                if($key != '_token'){
                    Answer::create([
                        'date_answer_id' => $date_answer->id,
                        'question_id' => $key,
                        'answer' => $answer, 
                    ]);
                }
            }

            foreach ($data_test_step_3 as $key => $answer) {
                if($key != '_token'){
                    Answer::create([
                        'date_answer_id' => $date_answer->id,
                        'question_id' => $key,
                        'answer' => $answer,
                    ]);
                }
            }

            foreach ($data_test_step_4 as $key => $answer) {
                if($key != '_token'){
                    Answer::create([
                        'date_answer_id' => $date_answer->id,
                        'question_id' => $key,
                        'answer' => $answer,
                    ]);
                }
            }

            session()->forget('test_step_1');
            session()->forget('test_step_2');
            session()->forget('test_step_3'); 
            session()->forget('test_step_4'); 
        });

        return redirect('/test/step-finish');
    }

    public function step_finish()
    {
        return view('main.test.done');
    }
}
