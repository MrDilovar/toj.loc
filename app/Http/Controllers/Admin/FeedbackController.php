<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;

class FeedbackController extends Controller
{
    protected $appeals = [
        'Благодарность',
        'Замечание',
        'Предложение'
    ];

    protected $categoryAppeals = [
        'Продукт',
        'Сервис',
        'Оплата',
        'Прочее'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Feedback::orderBy('id', 'desc')->get();

        foreach ($feedbacks as $feedback) {
            $feedback->data = $feedback->created_at->format('d-m-y / H:i');
        }

        return view('admin.feedback.index', ['feedbacks'=>$feedbacks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guest.feedback', ['appeals'=>$this->appeals, 'categoryAppeals'=>$this->categoryAppeals]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_inputs = [
            'appeal'=>'required|integer',
            'categoryAppeal'=>'required|integer',
            'contactName'=>'required|max:60',
            'contactReview'=>'required|max:600',
            'contactAgree'=>'required|accepted'

        ];

        if ( $request->contactPhone !== null ) {
            $validate_inputs['contactPhone'] = 'max:60';
        }

        if ( $request->contactEmail !== null ) {
            $validate_inputs['contactEmail'] = 'email|max:255';
        }

        $request->validate($validate_inputs);

        $feedback = new Feedback([
            'contactName'=>$request->contactName,
            'contactPhone'=>$request->contactPhone,
            'contactEmail'=>$request->contactEmail,
            'contactReview'=>$request->contactReview,
        ]);

        if ( array_key_exists($request->appeal, $this->appeals) )
            $feedback->appeal = $this->appeals[$request->appeal];

        if ( array_key_exists($request->categoryAppeal, $this->categoryAppeals) )
            $feedback->categoryAppeal = $this->categoryAppeals[$request->categoryAppeal];

        $feedback->save();

        return redirect()->back()->with('success', 'Ваш отзыв был отправлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->data = $feedback->created_at->format('d-m-y / H:i');

        return view('admin.feedback.show', ['feedback'=>$feedback]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect(route('admin.feedback.index'))->with('success', 'Отзыв был успешно удален');
    }
}
