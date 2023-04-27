<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Create a new FAQ.
     */
    public function createFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'required|string|in:general,technical',
        ]);

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->category = $request->category;
        $faq->slug = slugify($request->question);
        $faq->save();

        return new ApiResource([
            $faq,
            'status' => 201,
        ]);
    }

    /**
     * Update FAQ.
     *
     * @param mixed $faq_id
     */
    public function updateFaq(Request $request, $faq_id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'required|string|in:'.implode(',', AppConstants::FAQ_CATEGORIES),
        ]);

        $faq = Faq::find($faq_id);

        if (! $faq) {
            return new ApiResource([
                'message' => 'FAQ not found',
                'status' => 404,
            ]);
        }

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->category = $request->category;
        $faq->save();

        return new ApiResource([
            'data' => $faq,
        ]);
    }

    /**
     * Get all FAQs and group them by category.
     */
    public function getFaqs()
    {
        $faqs = Faq::all();

        $groupedFaqs = $faqs->groupBy('category');

        return new ApiResource([
            'data' => $groupedFaqs,
        ]);
    }

    /**
     * Delete FAQ.
     *
     * @param mixed $faq_id
     */
    public function deleteFaq($faq_id)
    {
        $faq = Faq::find($faq_id);

        if (! $faq) {
            return new ApiResource([
                'message' => 'FAQ not found',
                'status' => 404,
            ]);
        }

        $faq->delete();

        return new ApiResource([
            'message' => 'FAQ deleted successfully',
        ]);
    }
}
