<?php

use WpMailCatcher\Models\Logs;

class TestEmails extends WP_UnitTestCase
{
	public function setUp()
	{
		Logs::truncate();
	}

	public function testMail()
	{
		$to = 'test@test.com';
		$subject = 'subject';
		$message = 'message';
		$additionalHeaders = ['Content-type: text/html', 'cc: test1@test.com'];

		$imgAttachmentId = $this->factory()->attachment->create_upload_object(__DIR__ . '/../assets/img-attachment.png');
		$pdfAttachmentId = $this->factory()->attachment->create_upload_object(__DIR__ . '/../assets/pdf-attachment.pdf');

		wp_mail($to, $subject, $message, $additionalHeaders, [
			get_attached_file($imgAttachmentId),
			get_attached_file($pdfAttachmentId)
		]);

        $emailLogs = Logs::get();

        $this->assertCount(1, $emailLogs);
		$this->assertEquals($to, $emailLogs[0]['email_to']);
		$this->assertEquals($subject, $emailLogs[0]['subject']);
		$this->assertEquals($message, $emailLogs[0]['message']);

		$this->assertEquals($additionalHeaders[0], $emailLogs[0]['additional_headers'][0]);
		$this->assertEquals($additionalHeaders[1], $emailLogs[0]['additional_headers'][1]);

		$this->assertEquals($imgAttachmentId, $emailLogs[0]['attachments'][0]['id']);
		$this->assertEquals(wp_get_attachment_url($imgAttachmentId), $emailLogs[0]['attachments'][0]['url']);

		$this->assertEquals($pdfAttachmentId, $emailLogs[0]['attachments'][1]['id']);
		$this->assertEquals(wp_get_attachment_url($pdfAttachmentId), $emailLogs[0]['attachments'][1]['url']);

		wp_delete_attachment($imgAttachmentId);
		wp_delete_attachment($pdfAttachmentId);
	}

	public function testCorrectTos()
	{
		wp_mail('test@test.com', 'subject', 'message');
		$this->assertTrue(Logs::get()[0]['status']);
	}

	public function testIncorrectTos()
	{
		wp_mail('testtest.com', 'subject', 'message');
		$this->assertFalse(Logs::get()[0]['status']);
	}

    public function testHtmlEmail()
    {
        wp_mail('test@test.com', 'subject', 'message', ['Content-Type: text/html']);
        $this->assertTrue(Logs::get()[0]['is_html']);
    }

    public function testNonHtmlEmail()
    {
        wp_mail('test@test.com', 'subject', 'message');
        $this->assertFalse(Logs::get()[0]['is_html']);
    }
}
